<script lang="ts">
	let userName = '';
	let password = '';
	let isLoading = false; // New state variable to control loader visibility

	function handleLogin() {
		console.log('Logging in with', userName, password);
		
		isLoading = true; // Set loading state to true

            // Make a POST request to the login endpoint
            fetch('http://localhost/backend/backend/modules/auth.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ action: 'login', userName, password })
		})
		.then(response => response.json())
		.then(data => {
			console.log(data); // Log the entire response
			if (data.message === "Login successful") {
				console.log('User ID:', data.userId); // Ensure this matches the PHP response
				localStorage.setItem('user-id', data.userId); // Store the user ID
                window.location.href = '/dashboard';
			} else {
				console.error(data.message);
			}
			isLoading = false; // Reset loading state
		})
		.catch(error => {
			console.error('Error:', error);
			isLoading = false; // Reset loading state
		});
	}

	function handleSubmit() {
		handleLogin(); 
	}
</script>

<div class="flex flex-col min-h-screen md:flex-row">
    <div class="flex-1 bg-black flex items-center justify-center relative left-section">
       
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        
    </div>
    <div class="flex-1 flex items-center justify-center">
        <form action="login" on:submit|preventDefault={handleSubmit} class="p-6 w-full md:w-2/3">
            <p class="text-center mb-6 text-gray-600">Please enter your credentials to continue your journey in Code Masters.</p>
            <div class="mb-4">
                <label for="userName" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="userName" bind:value={userName} required class="mt-1 block w-full p-2 border border-gray-300 rounded" />
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" bind:value={password} required class="mt-1 block w-full p-2 border border-gray-300 rounded" />
            </div>
            <button type="submit" class="w-full bg-red-900 text-white p-2 rounded hover:bg-red-800">Log In</button>
            <p class="mt-4 text-center">Don't Have an Account? 
                <button type="button" class="text-red-500" on:click={() => window.location.href='/register'}>Register</button>
            </p>
            <p class="mt-2 text-center text-sm text-gray-500">Version 1.0.0 Developed by Michael Dayandante - Join the adventure!</p>
        </form>
    </div>
</div>
