<?php

namespace blog\enum;

enum IsChecked: int
{
    case checked = 1;
    case unverified = 0;
}
