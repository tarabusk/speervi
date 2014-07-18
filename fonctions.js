function EstUnEmail(chaine)
{ 
  var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
 
    if(reg.test(chaine))
    {
        return(true);
    }
    else
    {
        return(false);
    }
}
  
  $(document).ready( function () {
  
  })
