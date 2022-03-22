<?php

$parentfilename = basename(get_included_files()[0], '.php');

echo "<header>";

if($parentfilename == 'welcome')
{
  echo "<a href ='welcome.php' id = 'ph'>Home</a>";
}
else
{
  echo "<a href ='welcome.php' id = 'normal'>Home</a>";
}
////////////////////////////////////////////////////////////////////////////////
if($parentfilename == 'signup')
{
  echo "<a href ='signup.php' id = 'ph'>Sign Up</a>";
}
else
{
  echo "<a href ='signup.php' id = 'normal'>Sign Up</a>";
}
////////////////////////////////////////////////////////////////////////////////
if($parentfilename == 'login')
{
  echo "<a href ='login.php' id = 'ph'>Login</a>";
}
else
{
  echo "<a href ='login.php' id = 'normal'>Login</a>";
}
echo "</header>";
?>