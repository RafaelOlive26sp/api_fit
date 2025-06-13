<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('students.{studentId}', function ($user, $studentId) {
    // Check if the user is authorized to listen to this channel
    return (int) $user->id === (int) $studentId;
    // return true;
});
