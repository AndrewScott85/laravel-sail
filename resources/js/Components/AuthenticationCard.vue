
<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg">
            <slot />            
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 bg-black overflow-hidden sm:rounded-lg flex flex-col items-center">
            <slot name="demologin"/>            
        </div>
    </div>
</template>
