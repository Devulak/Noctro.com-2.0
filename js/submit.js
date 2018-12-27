function submit_function(e)
{
	e.preventDefault();

	// Get values
	var form = this;
	var formData = new FormData(form);







	// Ajax
	if (!form.classList.contains("wait"))
	{
		grecaptcha.ready(function() {
			grecaptcha.execute(recaptchaSiteKey, {action: 'login'})
			.then(function(token) {
				formData.append('grecaptcha', token);

				// Do Ajax
				ajax(form.action, formData, function(xml) {
					
					// Ajax Complete
					var errors = xml.getElementsByTagName("error");

					// If nothing ducks up
					if (errors.length == 0)
					{
						window.location.assign(xml.getElementsByTagName("redirect")[0].innerHTML);
						return;
					}
					else
					{
						// Remove loading stuff!
						form.classList.remove("wait");
					}

					// Remove label > sub
					var labels = form.getElementsByTagName("label");
					for (var i = labels.length - 1; i >= 0; i--)
					{
						var label = labels[i];
						if (label.dataset["error"])
						{
							var subs = label.getElementsByTagName("sub");
							for (var j = subs.length - 1; j >= 0; j--)
							{
								var sub = subs[j];
								sub.parentNode.removeChild(sub);
							}

							for (var j = errors.length - 1; j >= 0; j--)
							{
								var error = errors[j];

								if (label.dataset["error"] == error.getAttribute("name"))
								{
									var sub = document.createElement("sub");
									sub.innerHTML = error.innerHTML;
									label.appendChild(sub);
								}
							}
						}
					}

					// Remove password values
					var inputs = form.getElementsByTagName("input");
					for (var i = inputs.length - 1; i >= 0; i--)
					{
						var input = inputs[i];
						if (input.type == "password")
						{
							input.value = "";
						}
					}
				});

			});
		});
	}
	form.classList.add("wait");
}


// Run when you wanna refresh submitters
function submitter()
{
	// Actual code
	var forms = document.querySelectorAll("form.submit");
	for (var i = 0; i < forms.length; i++)
	{
		forms[i].removeEventListener("submit", submit_function); // Fix double posting
		forms[i].addEventListener("submit", submit_function);
	}
}
window.addEventListener("load", submitter);