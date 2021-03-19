<template>
    <div>
        <b-modal
            id="modal-oferta"
            :title="ofertaSeleccionada.titol"
            hide-footer
        >
            <p class="my-4">{{ ofertaSeleccionada.descripcio }}</p>
            <b-button @click="enviarCV()" variant="primary">Enviar CV</b-button>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "ModalOferta",
    props: {
        ofertaSeleccionada: Object,
    },
    data() {
        return {
            boxTwo: "",
        };
    },
    methods: {
        enviarCV() {
            this.boxTwo = "";
            this.$bvModal
                .msgBoxConfirm("¿Seguro que quieres enviar el CV?.", {
                    title: "Please Confirm",
                    size: "sm",
                    buttonSize: "sm",
                    okVariant: "danger",
                    okTitle: "Si",
                    cancelTitle: "No",
                    footerClass: "p-2",
                    hideHeaderClose: false,
                    centered: true,
                })
                .then((value) => {
                    this.boxTwo = value;
                    if (true == value) {
                        this.$bvModal.hide("modal-oferta");
                    }
                })
                .catch((err) => {
                    // An error occurred
                });
        },
    },
};
</script>

<style></style>
