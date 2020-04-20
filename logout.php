<?php
// logout handlers
session_start();

session_unset();

session_destroy();

header("Location: http://ecs.fullerton.edu/~cs431s42/assignment3/");