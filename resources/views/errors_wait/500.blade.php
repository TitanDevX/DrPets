@include('errors._layout', [
    'code' => 500,
    'title' => 'Server Error',
    'message' => "Something went wrong on our end. Please try again later.",
])
