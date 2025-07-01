<h3>Error Detected</h3>
<p><strong>Message:</strong> {{ $errorData['message'] }}</p>
<p><strong>Type:</strong> {{ $errorData['error_type'] }}</p>
<p><strong>File:</strong> {{ $errorData['file'] }} (line {{ $errorData['line'] }})</p>
<p><strong>User ID:</strong> {{ $errorData['user_id'] ?? 'Guest' }}</p>
<p><strong>URL:</strong> {{ $errorData['url'] }}</p>
