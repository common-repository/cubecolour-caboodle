document.addEventListener("DOMContentLoaded", function () {

	document.addEventListener("scroll", handleScroll);
	var scrolltop = document.querySelector(".scrolltop");

	function handleScroll() {
		var scrollableHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;

		if ((document.documentElement.scrollTop / scrollableHeight ) > 0.5 ) {
			if(!scrolltop.classList.contains("showscrolltop"))
			scrolltop.classList.add("showscrolltop")
		} else {
			if(scrolltop.classList.contains("showscrolltop"))
			scrolltop.classList.remove("showscrolltop")
		}
	}

	scrolltop.addEventListener("click", scrollToTop);

	function scrollToTop() {
		window.scrollTo({
			top: 0,
			behavior: "smooth"
		});
	}
});