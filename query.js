<script type="text/javascript">
function changeContent(str)
{
if (str=="")
  {
// if blank, we'll set our innerHTML to be blank.
document.getElementById("content").innerHTML="";
return;
  }
if (window.XMLHttpRequest)
{       // code for IE7+, Firefox, Chrome, Opera, Safari
// create a new XML http Request that will go to our generator webpage.
xmlhttp=new XMLHttpRequest();
}
else
{       // code for IE6, IE5
// create an activeX object
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
// on state change
xmlhttp.onreadystatechange=function()
{
// if we get a good response from the webpage, display the output
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("content").innerHTML=xmlhttp.responseText;
    }
  }
 // use our XML HTTP Request object to send a get to our content php.
xmlhttp.open("GET","getlist.php?GROUPNAME="+str, true);
xmlhttp.send();
}
</script>

