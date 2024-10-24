<template>
    <div v-if="asyncComponent">
        <component :is="asyncComponent" v-bind="$attrs" />
    </div>
    <div v-else-if="loading">
        Loading...
    </div>
    <div v-else>
        Error loading component: {{ error }}
    </div>
</template>

<script>
import { markRaw } from 'vue';

export default {
    props: {
        component: Promise
    },
    data() {
        return {
            asyncComponent: null,
            loading: true,
            error: null
        };
    },
    async mounted() {
        try {
            const module = await this.component;
            const component = module.default || module;
            if (!component || typeof component !== 'object') {
                throw new Error(`Invalid component export: ${module}`);
            }
            this.asyncComponent = markRaw(component);
            this.loading = false;
        } catch (error) {
            this.error = error;
            this.loading = false;
        }
    }
}
</script>