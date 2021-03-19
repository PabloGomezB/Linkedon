<template>
    <b-card
        :header="oferta.titol"
        v-b-modal.modal-oferta
        @click="abrirModal"
        border-variant="danger"
        v-if="
            new Date(oferta.data_publicacio) > this.getDate15daysSubstracted()
        "
    >
        <b-card-text>
            <p>
                {{ oferta.descripcio }}
            </p>
        </b-card-text>

        <template #footer>
            <small class="text-muted"
                >Data publicació: {{ oferta.data_publicacio }}</small
            >
        </template>
    </b-card>

    <b-card
        :header="oferta.titol"
        v-b-modal.modal-oferta
        @click="abrirModal"
        v-else
    >
        <b-card-text>
            <p>
                {{ oferta.descripcio }}
            </p>
        </b-card-text>

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
        getDate15daysSubstracted() {
            let date = new Date();
            date.setDate(date.getDate() - 15);
            return date;
        },
    },
};
</script>

<style></style>
