jQuery(document).ready(function($) {

  if (!Function.prototype.bind) {
    Function.prototype.bind = function(oThis) {
      if (typeof this !== 'function') {
        // closest thing possible to the ECMAScript 5
        // internal IsCallable function
        throw new TypeError('Function.prototype.bind - what is trying to be bound is not callable');
      }

      var aArgs   = Array.prototype.slice.call(arguments, 1),
          fToBind = this,
          fNOP    = function() {},
          fBound  = function() {
            return fToBind.apply(this instanceof fNOP && oThis
                   ? this
                   : oThis,
                   aArgs.concat(Array.prototype.slice.call(arguments)));
          };

      fNOP.prototype = this.prototype;
      fBound.prototype = new fNOP();

      return fBound;
    };
  }

  contact_search =
  {
      search: function(params) {
              //do the query
              var nameTerm = "q=" + params.initial + "%20" + params.lastname;
              var mediumTerm = "medium=" + params.medium;
              var exactTerm = "match=" + params.match;

              var query = nameTerm + "&" + mediumTerm + "&" + exactTerm;
              var url = this.url + query;

              $.ajax({
                  url: url,
                  type: 'get',
                  dataType: 'json',
                  success: this.displayResults.bind(this),

                  failure: function(response) {
                      console.error("Failed to retrieve contact results");
                  }
              });
      },
      create_form : function (params) {
          this.el = params.el;
          this.prefill = params.prefill;
          this.url = params.url? params.url : '//api.m.ox.ac.uk/contact/search?';
          this.pageSize = params.pageSize ? params.pageSize : 10;
          this.bind_events();

          if(params.prefill) {
              //fill in the form
              if(params.prefill.initial) {
                  $('input#initial', this.el).val(params.prefill.initial);
              } else { params.prefill.initial = ""; }
              if(params.prefill.lastname) {
                  $('input#lastname', this.el).val(params.prefill.lastname);
              } else { params.prefill.lastname = ""; }
              if(params.prefill.match) {
                  if(params.prefill.match == 'approximate') {
                      $('input#exact2').attr('checked', 'checked');
                  }
              } else { params.prefill.exact = true; }
              //default to email
              if(!params.prefill.medium) { params.prefill.medium = 'email' }
              this.search(params.prefill);
          }

          if(params.autofocus) {
              $('input#lastname').focus();
          }
      },
      bind_events : function () {
          //record which button was clicked on submit button click
          $( 'button[type=submit]' , $(this.el)).click( function() {
              //Add a data attribute to the form based on the clicked button
              var medium = $(this).val();
              $(this).parents('form').data('medium', $(this).data('medium'));
          });

          //form submit
          $(this.el).submit(function(ev) {
             ev.preventDefault();
              //extract values from the form to build our query
              var lastname = $('input#lastname', $(ev.target)).val();
              var initial = $('input#initial', $(ev.target)).val();
              var match = $('input#exact-e').is(':checked') ? 'exact' : 'approximate';
              var medium = $(ev.target).data('medium');
              var params = { lastname: lastname, initial: initial, match: match, medium: medium };
              this.search(params);

          }.bind(this));
      },
      displayResults : function(response) {
        console.log(response);
          this.persons = response.persons;
          //create results div if it doesn't already exist
          var $results = $('.contact-results', this.el);
          $results.empty().show();
          $results.prepend($('<span class="contact-close">Close<i class="fa fas fa-times"></i></span>')).find('.contact-close').click(function() {
						jQuery(this).parent().slideUp('slow');
					});
          var $resultsHeader = $("<div class='results-header'></div>");
          $results.append($resultsHeader);
          $resultsHeader.append($("<h2>Results</h2>"));
          var entriesNoun = response.persons.length ==1 ? ' entry' : ' entries'
          $resultsHeader.append($("Found " + response.persons.length + entriesNoun + ""));
          var $list = $("<ul class='contact-results-list'></ul>");
          $results.append($list);

          //populate table
          for(var i=0; i<response.persons.length; i++) {

              var person = response.persons[i];
              var $entry = $("<li id='person_" + (i+1) + "' class='person_entry'></li>");

              $list.append($entry);
              //name
              var $name = $("<div id='name-" + (i+1) + "' class='person_name'></div>");
              $name.append($("<h3>" + person.name + "</h3>"));
              $entry.append($name);

              //container for unit and email, to keep those together on RHS
              var $person_details = $("<div class=details></div>");
              $entry.append($person_details);
              //unit
              var unitText = person.unit ? person.unit : "    ";
              var $unit = $("<div id='unit-" + (i+1) + "' class='person_unit'></div>");
              $unit.text(unitText);
              $person_details.append($unit);
              //email
              if(person.email) {
                  var $email = $("<div id='email-" + (i+1) + "' class='person_email'></div>");
                  $email.append($("<a href='mailto:" + person.email + "'>" + person.email + "</a>"));
                  $person_details.append($email);
              }
              //phone
              if(person.external_tel || person.internal_tel) {
                  var $phone = $("<div id='phone-" + (i+1) + "' class='person_phone'></div>");
                  var $phone_list = $("<dl></dl>");
                  $phone.append($phone_list);
                  if(person.internal_tel) {
                      $phone_list.append($("<dt>Internal</dt><dd>" + person.internal_tel + "</dd>"));
                  }
                  if(person.external_tel) {
                      $phone_list.append($("<dt>External</dt><dd>" + person.external_tel + "</dd>"));
                  }
                  $entry.append($phone);
              }
          }

          this.numPages = Math.ceil(this.persons.length / this.pageSize);

          if(this.numPages >1) {
              //create page browsing links
              var $pageLinks = $("<ul class='pagination'></ul>");
              $results.append($pageLinks);
              var $prevPage = $("<li class='prev'><span>Prev</span></li>");
              $prevPage.click(this.prevPage.bind(this));
              var $nextPage = $("<li class='next'><span>Next</span></li>");
              $nextPage.click(this.nextPage.bind(this));
              $pageLinks.append($prevPage);
              for (var i = 0; i < this.numPages; i++) {
                  var $link = $("<li class='link page_" + i + "'><span>" + (i + 1) + "</span></li>");
                  $link.click(this.onClickPageLink.bind(this));
                  $link.data('page', i);
                  $pageLinks.append($link);
              }
              $pageLinks.append($nextPage);
              var $pageCounter = ($("<div class='results-pages'> Page <span class='currentPage'>0</span> of " + this.numPages + "</div>"));
              $results.append($pageCounter.clone());
              $resultsHeader.append($pageCounter);
          }
          $results.append($("<div class='details-incorrect'><a href='//staff.admin.ox.ac.uk/how-do-i/update-my-details-in-contact-search-on-the-staff-gateway'>Contact details incorrect?</a></div>"));

          this.currentPage = 0;

          //show the first page of results
          this.displayResultsPage(0);
      },
      prevPage : function(ev) {
          ev.preventDefault();
          if (this.currentPage < 1) return;
          this.currentPage--;
          this.displayResultsPage(this.currentPage);
      },
      nextPage : function(ev) {
          ev.preventDefault();
          if (this.currentPage >= this.numPages-1) return;
          this.currentPage++;
          this.displayResultsPage(this.currentPage);
      },
      onClickPageLink : function(ev) {
          var $pager = $(ev.currentTarget);
          var page = parseInt($pager.find('span').html()) - 1;
          this.displayResultsPage(page);
      },
      // Display the given page of results. count=results per page, start=0-index page number
      displayResultsPage : function(pageNumber) {
          this.currentPage = pageNumber;

          var first_shown_result = this.pageSize * pageNumber;

          //hide all but the relevant results
          $('.person_entry').hide();
          //unhide the relevant ones
          for(var i=this.pageSize*pageNumber; i<this.pageSize*(pageNumber+1); i++) {
              if (i<this.persons.length) {
                  var id = '#person_' + (i + 1);
                  $(id).show();
              }
          }

          //show current page on pagination links
          $('li.link').removeClass('active');
          var $currentPageLink = $('li.page_' + pageNumber);
          $currentPageLink.addClass('active');
          $('.currentPage').text(pageNumber+1);

          //disable prev/next links as appropriate
          var $prev = $('li.prev');
          if(this.currentPage == 0) {
              $prev.addClass('disabled');
          } else {
              $prev.removeClass('disabled');
          }

          var $next = $('li.next');
          if(this.currentPage >= this.numPages-1) {
              $next.addClass('disabled');
          } else {
              $next.removeClass('disabled');
          }
      }
  }

}(jQuery));