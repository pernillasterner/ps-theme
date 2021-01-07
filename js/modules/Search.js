import $ from 'jquery';

class Search 
{
  // 1. Describe and create/initiate the object
  constructor() {
    // Properties about the object
    this.addSearchHTML();
    this.resultsDiv = $("#search-overlay__results");
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.events();
    this.isOverlayOpen = false; // Makes the keydown event only run once
    this.isSpinnerVisible;
    this.previousValue;
    this.typingTimer;
  }

  // 2. Events
  events() {
    this.openButton.on('click', this.openOverlay.bind(this));
    this.closeButton.on('click', this.closeOverlay.bind(this));
    $(document).on('keydown', this.keyPressDispatcher.bind(this));
    this.searchField.on('keyup', this.typingLogic.bind(this));
  }

  // 3. Methods / Actions
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    // Removes the search results after closing and open the serach icon
    this.searchField.val('');
    setTimeout(() => this.searchField.focus(), 301);
    this.openOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.openOverlayOpen = false;
  }

  keyPressDispatcher(e) {
    if(e.keyCode == 83 && !this.openOverlayOpen) {
      this.openOverlay();
    }
    if(e.keyCode == 187 && this.openOverlayOpen) {
      this.closeOverlay();
    }
  }

  typingLogic() {
    if(this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);

      if(this.searchField.val()) {

        if(!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultsDiv.html('');
        this.isSpinnerVisible = false;
      }
    }
    this.previousValue = this.searchField.val();
  }

  getResults() {
    $.getJSON(themeData.root_url + '/wp-json/ps-theme/v1/search?term=' + this.searchField.val(), (results) => {
      this.resultsDiv.html(`
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General info</h2>
            ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search</p>'}
              ${results.generalInfo.map(item => `<li><a href='${item.permalink}'>${item.title}</a>${item.postType == 'post' ? ` by ${item.authorName}`: ''}</li>`).join('')}
            ${results.generalInfo.length ? '</ul>' : ''}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
            ${results.programs.length ? '<ul class="link-list min-list">' : `<p>No programs matches that search <a href="${themeData.root_url}/programs">View all programs</a></p>`}
              ${results.programs.map(item => `<li><a href='${item.permalink}'>${item.title}</a></li>`).join('')}
            ${results.programs.length ? '</ul>' : ''}
            <h2 class="search-overlay__section-title">Professors</h2>
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Campuses</h2>
            ${results.campuses.length ? '<ul class="link-list min-list">' : `<p>No campuses matches that search <a href="${themeData.root_url}/campuses">View all campuses</a></p>`}
              ${results.campuses.map(item => `<li><a href='${item.permalink}'>${item.title}</a></li>`).join('')}
            ${results.campuses.length ? '</ul>' : ''}

            <h2 class="search-overlay__section-title">Events</h2>
          </div>
        </div>
      `);
      this.isSpinnerVisible = false;
    });
  }

  addSearchHTML() {
    $('body').append(`
      <div class="search-overlay">
      <div class="search-overlay__top">
        <div class="container">
          <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
          <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" autocomplete="off">
          <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
        </div>
      </div>

      <div class="container">
        <div id="search-overlay__results"></div>
      </div>
    </div>
    `);
  }
}

export default Search;