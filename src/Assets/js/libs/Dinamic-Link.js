!(function() {
	
	const attrOpen = document.querySelectorAll('[dinamic-link]');
	const attrBlockOpen = document.querySelectorAll('[dinamic-block]');
	const attrOpenDefault = document.querySelectorAll('[dinamic-default]');
	
	for(let i = 0; i < attrOpenDefault.length; i++) {
		
		const addActiveDefault = attrOpenDefault[i].attributes['dinamic-default'].nodeValue;
		
		if(addActiveDefault != 'false') {
			document.querySelector('[dinamic-block="' + addActiveDefault + '"]').classList.add('active');
			document.querySelector('[dinamic-link="' + addActiveDefault + '"]').classList.add('active');
		}
		
		attrOpenDefault[i].removeAttribute('dinamic-default');	
		
	}
	
	for(let e = 0; e < attrOpen.length; e++) {
		
		const dataOpen = attrOpen[e].attributes['dinamic-link'].nodeValue;
		
		attrOpen[e].onclick = () => {
			
			$('[dinamic-block]').removeClass('active');
			$('[dinamic-link]').removeClass('active');
			
			document.querySelector('[dinamic-block="' + dataOpen + '"]').classList.add('active');
			document.querySelector('[dinamic-link="' + dataOpen + '"]').classList.add('active');
			
		}
		
	}
	
})();