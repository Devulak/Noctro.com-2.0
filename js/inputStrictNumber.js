function strictNumber()
{
	var number = getNumber(this.value);

	number = number < this.min ? parseInt(this.min) : number;
	number = number > this.max ? parseInt(this.max) : number;

	this.value = number;
}

function getNumber(string)
{
	// Find a number in the string
	var re = /(\d+)/;
	results = re.exec(string);

	if (!results)
	{
		return 0;
	}
	return parseInt(results[0]);
}

function AddStrictNumbers()
{
	// Actual code
	var inputs = document.querySelectorAll("input.strictNumber");
	for (var i = inputs.length - 1; i >= 0; i--)
	{
		inputs[i].addEventListener("input", strictNumber);
	}
}
window.addEventListener("load", AddStrictNumbers);