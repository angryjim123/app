<?php
$parentfilename = basename(get_included_files()[0], '.php');

//header
echo "<header id = 'homeheader'>
        <div id = 'headerleft'>
          <a href='homepage.php'>
           <img alt='Logo' src='photos/jeremy.jpg' id = 'logoimage'>
          </a>
        </div>
        <div id = 'headermiddle'>";

if($parentfilename == 'homepage' || $parentfilename == 'commentfeed')
{
  echo "<a href ='homepage.php' id = 'ph'>Feed</a>";
}
else
{
  echo "<a href ='homepage.php' id = 'normal'>Feed</a>";
}
////////////////////////////////////////////////////////////////////////////////
if($parentfilename == 'post')
{
  echo "<a href ='post.php' id = 'ph'>Post</a>";
}
else
{
  echo "<a href ='post.php' id = 'normal'>Post</a>";
}
////////////////////////////////////////////////////////////////////////////////
if($parentfilename == 'search' || $parentfilename == 'searchaccount' || $parentfilename == 'clickaccount' || $parentfilename == 'commentclick')
{
  echo "<a href ='search.php' id = 'ph'>Search</a>";
}
else
{
  echo "<a href ='search.php' id = 'normal'>Search</a>";
}
////////////////////////////////////////////////////////////////////////////////
if($parentfilename == 'profile' || $parentfilename == 'editprofile' || $parentfilename == 'comment')
{
  echo "<a href ='profile.php' id = 'ph'>Profile</a>";
}
else
{
  echo "<a href ='profile.php' id = 'normal'>Profile</a>";
}


echo "</div>
        <div id = 'headerright'>
          <a href='logout.php'>
           <img alt='Logout' src='photos/jeffrey.jpg' id = 'logoutimage'>
          </a>
        </div>
      </header>";
?>