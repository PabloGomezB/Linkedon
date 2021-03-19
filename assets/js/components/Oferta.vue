<template>
    <b-card :title="oferta.titol">
        <b-card-text>
            <p>
                {{ oferta.descripcio }}
            </p>
        </b-card-text>
        <b-button v-b-modal.modal-oferta @click="abrirModal" variant="primary"
            >Abrir</b-button
        >

        <template #footer>
            <small class="text-muted"
                >Data publicació: {{ oferta.data_publicacio }}</small
            >
        </template>
    </b-card>
</template>

<script>
export default {
    name: "Oferta",
    props: { oferta: Object },
    methods: {
        abrirModal() {
            this.$parent.ofertaSeleccionada = this.oferta;
        },
    },
};
</script>

<style></style>
