/*
 * If u want integrate that, i've create a library for use ripple in your
 * beautifoul projects 🤙
 *
 * Here the link:
 * https://github.com/tomma5o/touchMyRipple
 */

const isMobile = window.navigator.userAgent.match(/Mobile/) && window.navigator.userAgent.match(/Mobile/)[0] === "Mobile";
const event = isMobile ? "touchstart" : "click";

const button = document.querySelectorAll('*[data-animation="ripple"]'),
			container = document.querySelector(".__container");

for (var i = 0; i < button.length; i++) {
	const currentBtn = button[i];
	
	currentBtn.addEventListener(event, function(e) {
		
		e.preventDefault();
		const button = e.target,
					rect = button.getBoundingClientRect(),
					originalBtn = this,
					btnHeight = rect.height,
					btnWidth = rect.width;
                                       
		let posMouseX = 0,
				posMouseY = 0;
		
		if (isMobile) {
			posMouseX = e.changedTouches[0].pageX - rect.left;
			posMouseY = e.changedTouches[0].pageY - rect.top;
		} else {
			posMouseX = e.pageX - rect.left;
			posMouseY = e.pageY - rect.top;
		}
		
		const baseCSS = `position: absolute;
				width: ${btnWidth * 2}px;
				height: ${btnWidth * 2}px;
				transition: all linear 700ms;
				transition-timing-function:cubic-bezier(0.250, 0.460, 0.450, 0.940);
				border-radius: 50%;
				background: var(--color-ripple);
				top:${posMouseY - btnWidth}px;
				left:${posMouseX - btnWidth}px;
				pointer-events: none;
				transform:scale(0)`;
		
		var rippleEffect = document.createElement("span");
		rippleEffect.style.cssText = baseCSS;
		
		//prepare the dom
		currentBtn.style.overflow = "hidden";
		this.appendChild(rippleEffect);
		
		//start animation
		setTimeout( function() { 
			rippleEffect.style.cssText = baseCSS + `transform:scale(1); opacity: 0;`;
		}, 5);
		
		setTimeout( function() {
			rippleEffect.remove();
			//window.location.href = currentBtn.href;
		},700);
	});
}
