<?php

namespace blog\enum;

enum Is_checked: int 
{
    case checked = 1;
    case unverified = 0;
}