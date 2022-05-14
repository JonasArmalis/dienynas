<?php

function compare1 ($a, $b): int 
{
    return
    ($a["name"] <=> $b["name"]) * 10 + // name DESC
    ($a["surname"] <=> $b["surname"]);// surname DESC
}

function compare2 ($a, $b): int 
{
    return
    ($b["avg"] <=> $a["avg"]) * 100 + // grade average DESC
    ($a["name"] <=> $b["name"]) * 10 + // name DESC
    ($a["surname"] <=> $b["surname"]);// surname DESC
}

function compare3 ($a, $b): int 
{
    return
    ($b["avg"] <=> $a["avg"]) * 10 + // name DESC
    ($a["class"] <=> $b["class"]);// surname DESC
}

