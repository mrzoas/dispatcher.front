//#128c50
color_setup();
function color_setup()
{
	if (getCookie("theme") ==  undefined)
	{
		document.cookie = "theme=white";
	}
	if (getCookie("theme") == "white")
	{
		document.documentElement.style.setProperty('--background-color', '#ffffff');
		document.documentElement.style.setProperty('--background-image', 'url("../rsc/background-white.svg")');
	}
	else if(getCookie("theme") == "dark")
	{
		document.documentElement.style.setProperty('--background-color', '#000000');
		document.documentElement.style.setProperty('--background-image', 'url("../rsc/background-dark.svg")');
	}
	else
	{
		document.documentElement.style.setProperty('--background-color', '#767676');
		document.documentElement.style.setProperty('--background-image', 'url("../rsc/background-light.svg")');
	}
}