function Dust(canvas, amount = 1)
{
	this.canvas = canvas;
	this.amount = amount;
	this.elements = [];
	this.ctx = this.canvas.getContext("2d");

	this.canvas.width = document.documentElement.clientWidth;
	this.canvas.height = document.documentElement.clientHeight;

	window.addEventListener('resize', function(){
		this.canvas.width = document.documentElement.clientWidth;
		this.canvas.height = document.documentElement.clientHeight;
	});

	// Timer of the animation of the particles, only loops for the current particles and add new ones if required
	setInterval(function(){

		// Debug
		//console.log("test" + (new Date().getSeconds()));

		updateCanvas();

	}, 1000/144); // 144 Hz
	/**/
	function startAnimation()
	{
		// Debug
		//console.log("test" + (new Date().getSeconds()));

		drawCanvas();

		requestAnimationFrame(startAnimation);
	}
	requestAnimationFrame(startAnimation);
	/**/

	function updateCanvas()
	{
		// Set the max amount of elements allowed to be created
		maxElements = Math.ceil(this.canvas.width*this.canvas.height/(1920*1080)*250*this.amount);
		totalElements = this.elements.length;

		// Add elements to the array if needed
		for (var i = 0; i < (maxElements-totalElements); i++)
		{
			this.elements.push(createDustParticle());
		}

		// Do specific stuff with each element
		for (var i = 0; i < this.elements.length; i++)
		{
			updateDustParticle(this.elements[i]);

			// Can't point at the pointer while inside itself, gotta extract if it's suppose to be deleted
			if(!this.elements[i]['active'])
			{
				this.elements.splice(i, 1);
				// Because javascript can't handle key moving while working with the array itself
				i--;
			}
		}
	}

	function drawCanvas()
	{
		// Clear canvas
		this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

		// Draw each dusk particle
		for (var i = 0; i < this.elements.length; i++)
		{
			drawDustParticle(this.elements[i]);
		}
	}

	function createDustParticle()
	{
		speed = .25;

		element = [];
		element['x'] = randomize(0, this.canvas.width);
		element['y'] = randomize(0, this.canvas.height);
		element['velocity'] = [];
		element['velocity']['x'] = randomize(-speed, speed);
		element['velocity']['y'] = randomize(-speed, speed);
		element['size'] = randomize(2, 5);
		element['active'] = true;
		element['opacity'] = 0;
		element['opacityPotential'] = 0;
		element['opacityMin'] = randomize(.01, .05);
		element['opacityMax'] = randomize(.05, .1);
		element['opacityTimer'] = 0;
		element['opacityTimerSlowdown'] = randomize(25, 100);
		return element;
	}

	// Make a function to simple and effective randomize stuff
	function randomize(min, max)
	{
		return Math.random() * (max - min) + min;
	}

	function updateDustParticle(element)
	{
		element['x'] += element['velocity']['x'];
		element['y'] += element['velocity']['y'];
		element['opacityTimer']++;
		element['opacityPotential'] += (element['opacityPotential'] < 1) ? 0.01 : 0;
		element['opacity'] = ((-(Math.cos(element['opacityTimer'] / element['opacityTimerSlowdown'])-1)/2)*(element['opacityMax'] - element['opacityMin']) + element['opacityMin'])*element['opacityPotential'];

		// Delete if out of reach
		if(
			(element['x'] < -element['size']/2) ||
			(element['x'] > this.canvas.width+element['size']/2) ||
			(element['y'] < -element['size']/2) ||
			(element['y'] > this.canvas.height+element['size']/2)
		)
		{
			element['active'] = false;
		}
	}

	function drawDustParticle(element)
	{
		this.ctx.beginPath();
		this.ctx.arc(element['x'], element['y'], element['size']/2, 0, 2*Math.PI);
		this.ctx.fillStyle = 'rgba(255,255,255,' + element['opacity'] + ')';
		this.ctx.fill();
		this.ctx.closePath();
	}
}