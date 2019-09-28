//document.cookie = "user=John";
//document.cookie = "passwd=12312";

function getCookie(name)
{
 	let matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
 	return matches ? decodeURIComponent(matches[1]) : undefined;
}
function deleteCookie(name)
{
	setCookie(name, "", {'max-age': -1})
}


//alert(getCookie("user"));