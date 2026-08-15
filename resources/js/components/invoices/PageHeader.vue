<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';


const props=defineProps({
    title:{ 
        type: String, 
        default:''
    }, 
    item:{
        type: String,
        default:''
    },
    description:{ 
        type: String,
        default:''
    }, 
    actionButton:{
        type:String,
        default:'← Back'
    },
    actionButtonAddress:{
        type: String,
        default:''
    },  
    variant: {
    type: String,
    default: 'btnWhite',
    validator: (value) => ['btnBlack', 'btnWhite'].includes(value)
  }
})
const styles = {
  btnWhite: 'inline-flex items-center justify-center rounded-lg bg-background px-4 py-2.5 text-sm font-medium border border-border text-foreground transition hover:bg-muted',
  btnBlack: 'inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-primary-foreground transition hover:bg-primary/90'
}
const currentClass = computed(() => styles[props.variant])

    
</script>
<template>
            <div
            class="flex flex-col p-3 gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>

                <h1
                    class="mt-1 text-3xl font-bold tracking-tight text-foreground"
                >
                    {{title}} {{ item }}
                </h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    {{description}}
                </p>
            </div>

            <Link
                :href=  "actionButtonAddress"
                :class="currentClass"
            >
               <slot>{{ actionButton }}</slot> 
            </Link>
        </div>
    
</template>