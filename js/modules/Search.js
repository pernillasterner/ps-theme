import $ from 'jquery';

class Search 
{
  // 1. Describe and create/initiate the object
  constructor() {
    // Properties about the object
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.events();
    this.isOverlayOpen = false; // Makes the keydown only run once
  }

  // 2. Events
  events() {
    this.openButton.on('click', this.openOverlay.bind(this));
    this.closeButton.on('click', this.closeOverlay.bind(this));
    $(document).on('keydown', this.keyPressDispatcher.bind(this));
  }

  // 3. Methods / Actions
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
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
    if(e.keyCode == 8 && this.openOverlayOpen) {
      this.closeOverlay();
    }
  }

}

export default Search;