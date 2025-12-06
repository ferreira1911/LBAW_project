<?php

namespace App\Enums;

enum ReportStatus: string
{
    case Pending = 'Pending';
    case InReview = 'InReview';
    case Resolved = 'Resolved';

    case Dismissed = 'Dismissed';
}