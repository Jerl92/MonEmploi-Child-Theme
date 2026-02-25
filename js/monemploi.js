jQuery(document).ready(function () {
	// Get the scroll container element
	const scrollContainer = document.querySelector('#top-menu-container');
	
	// Example function to scroll to a specific position (e.g., 200 pixels from the left)
	function scrollToPosition() {
	    // You can also use Element.scroll() for a smoother effect
	    scrollContainer.scroll({
	        left: 200,
	        behavior: 'smooth'
	    });
	}
	
	// Example: Scroll to the end of the content
	function scrollToEnd() {
	    scrollContainer.scroll({
	        left: scrollContainer.scrollWidth, // The total width of the content
	        behavior: 'smooth'
	    });
	}
});