array_viewer
============

JSON, Array viewer for PHP

example
============
<code>
<?php
include('array_viewer.php');

$data=array(
  'a'=>'aaaa',
  'b'=>'bbbb',
  'c'=>array(
    'cc'=>array(
      'ccc'=>'ccccccc',
      'ccc2'=>'ccccccc2',
    ),
  ),
);
json_viewer($data);

die('');
?>
</code>
