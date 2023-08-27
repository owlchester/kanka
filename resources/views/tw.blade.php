This file is never loaded, but needed to trick tailwind to include some classes which aren't clearly written in the code. For example `bg-{{ $colour }}` won't be detected. For this, we have this file.

<div class="md:col-span-1 md:col-span-2 md:col-span-3 md:col-span-4 md:col-span-5 md:col-span-6 md:col-span-7 md:col-span-8 md:col-span-9 md:col-span-10 md:col-span-11 md:col-span-12"></div>

<div class="border-red-500"></div>

<div class="md:table-cell sm:table-cell lg:table-cell"></div>

<template id="moon-colours">
    <div class="text-blue-500"></div>
    <div class="text-orange-900"></div>
    <div class="text-green-500"></div>
    <div class="text-blue-300"></div>
    <div class="text-pink-800"></div>
    <div class="text-blue-900"></div>
    <div class="text-orange-500"></div>
    <div class="text-pink-500"></div>
    <div class="text-purple-500"></div>
    <div class="text-red-500"></div>
    <div class="text-teal-500"></div>
    <div class="text-yellow-500"></div>
    <div class="text-gray-500"></div>
</template>
