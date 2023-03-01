<!DOCTYPE html>
<html>
<head>
	<title>Success Message</title>
	<style>
		.container {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}
		.message {
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="message">
			<h1>{{ $header }}</h1>
			<p>{{ $message }}</p>
            <a href="{{ route('customer.viewCustomer') }}"> Home</a>
		</div>
	</div>
</body>
</html>
