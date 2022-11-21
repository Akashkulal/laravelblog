@extends('layouts.app')

@section('content')
<form action="" method="GET">
    <input type="text" name="name">
    <button type="submit">Submit</button>
</form>
<?php
$x=20;
$y=20;

if($x==$y && 1==1){
    echo "true";
}
?>

@endsection
