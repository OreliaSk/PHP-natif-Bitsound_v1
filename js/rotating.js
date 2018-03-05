
	const InfiniteRotator = 
	{
		init: function()
		{
			//initial fade-in time (in milliseconds)
			let initialFadeIn = 10;
			
			//interval between items (in milliseconds)
			let itemInterval = 200;
			
			//cross-fade time (in milliseconds)
			let fadeTime = 25;
			
			//count number of items
			let numberOfItems = $('.rotating-item').length;

			//set current item
			let currentItem = 0;

			//show first item
			$('.rotating-item').eq(currentItem).fadeIn(initialFadeIn);

			//loop through the items		
			let infiniteLoop = setInterval(function(){
				$('.rotating-item').eq(currentItem).fadeOut(fadeTime);

				if(currentItem == numberOfItems -1){
					currentItem = 0;
				}else{
					currentItem++;
				}
				$('.rotating-item').eq(currentItem).fadeIn(fadeTime);

			}, itemInterval);	
		}	
	};

	InfiniteRotator.init();
	
