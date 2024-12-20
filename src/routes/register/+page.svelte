<script lang="ts">
    let password = '';
    let userName = '';
    let errorMessage = '';

    const handleSubmit = async () => {
        // Prepare the data to be sent
        const data = {
            action: 'register',
            userName,
            password
        };

        try {
            const response = await fetch('http://localhost/backend/backend/modules/auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            // Error Checking / Error response
            const result = await response.text();
            console.log(result); 

            if (response.ok) {
                console.log('Registered succesfully');
                window.location.href = '/login';
            }
        } catch (error) {
            console.error('Error:', error);
        }
    };
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
        <form on:submit|preventDefault={handleSubmit} class="p-6 w-full md:w-2/3">
            <p class="text-center mb-6 text-gray-600">To get started, please fill in your details to create an account.</p>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" bind:value={userName} required class="mt-1 block w-full p-2 border border-gray-300 rounded" placeholder="Enter your username"/>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" bind:value={password} required class="mt-1 block w-full p-2 border border-gray-300 rounded" placeholder="Enter your password"/>
            </div>
            
            <button type="submit" class="w-full bg-red-900 text-white p-2 rounded hover:bg-red-800">Register</button>
            <p class="mt-4 text-center">Already Have an Account? <button type="button" class="text-red-500" on:click={() => window.location.href='/login'}>Login Now</button></p>
            <p class="mt-2 text-center text-sm text-gray-500">Version 1.0.0 Developed by Michael Dayandante - Join the adventure!</p>
        </form>
    </div>
</div>
