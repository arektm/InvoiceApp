<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500">
	 xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 40 42"
        :class="className"
        v-bind="$attrs"
	<path 
		fill="currentColor"
        fill-rule="evenodd"
        clip-rule="evenodd"
		
		
		
		d="M 86.902 168.136 L 315.491 98.237 L 392.317 278.337 L 287.153 307.935 L 235.516 200.252 L 113.35 236.146 L 86.902 168.136 Z"
	/>
	<path
		fill="currentColor"
        fill-rule="evenodd"
        clip-rule="evenodd"
	
		
		
		
		d="M 220.386 226.982 L 117.758 256.111 L 180.101 434.322 L 430.73 	365.053 L 400.504 298.932 L 273.254 336.696 L 220.386 226.982 Z"
	/>
	</svg>
</template>
