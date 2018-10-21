<template>
    <div class="text-center error-box">
        <img :src="address" width="28">
        <p class="text-muted">Carregando...</p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                address: ''
            }
        },
        created() {
            this.address = addr + "/svg/loading.svg";
        }
    };
</script>