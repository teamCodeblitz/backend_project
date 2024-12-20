<script lang="ts">
    import { onMount } from 'svelte';
    import CryptoJS from 'crypto-js';

    type Student = {
        studno: string;
        fname: string;
        mname: string;
        lname: string;
        birthdate: string;
        email: string;
        contact_number: string;
        complete_address: string;
    };

    let students: Student[] = [];

    onMount(async () => {
        try {
            const response = await fetch('http://localhost/backend_project/backend/modules/get.php');
            if (response.ok) {
                const encryptedText = await response.text();
                const key = CryptoJS.enc.Utf8.parse('1234567890123456');
                const iv = CryptoJS.enc.Utf8.parse('1234567890123456');
                const bytes = CryptoJS.AES.decrypt(encryptedText, key, { iv: iv, mode: CryptoJS.mode.CBC });
                const decryptedData = bytes.toString(CryptoJS.enc.Utf8);
                students = JSON.parse(decryptedData);
            } else {
                console.error('Failed to fetch students');
            }
        } catch (error) {
            console.error('Error fetching students:', error);
        }
    });
</script>

<table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-300">
    <thead class="bg-gray-800 text-white">
        <tr>
            <th class="py-3 px-4 text-left border-b border-gray-300">Student Number</th>
            <th class="py-3 px-4 text-left border-b border-gray-300">First Name</th>
            <th class="py-3 px-4 text-left border-b border-gray-300">Middle Name</th>
            <th class="py-3 px-4 text-left border-b border-gray-300">Last Name</th>
            <th class="py-3 px-4 text-left border-b border-gray-300">Birthdate</th>
            <th class="py-3 px-4 text-left border-b border-gray-300">Email</th>
            <th class="py-3 px-4 text-left border-b border-gray-300">Contact Number</th>
            <th class="py-3 px-4 text-left border-b border-gray-300">Complete Address</th>
        </tr>
    </thead>
    <tbody class="text-gray-700">
        {#each students as student}
            <tr class="border-b hover:bg-gray-200 transition duration-200">
                <td class="py-3 px-4 border-b border-gray-300">{student.studno}</td>
                <td class="py-3 px-4 border-b border-gray-300">{student.fname}</td>
                <td class="py-3 px-4 border-b border-gray-300">{student.mname}</td>
                <td class="py-3 px-4 border-b border-gray-300">{student.lname}</td>
                <td class="py-3 px-4 border-b border-gray-300">{student.birthdate}</td>
                <td class="py-3 px-4 border-b border-gray-300">{student.email}</td>
                <td class="py-3 px-4 border-b border-gray-300">{student.contact_number}</td>
                <td class="py-3 px-4 border-b border-gray-300">{student.complete_address}</td>
            </tr>
        {/each}
    </tbody>
</table>
