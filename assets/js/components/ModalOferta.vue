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
        userLogged: Object,
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
                    title: "Porfavor confirma",
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
                        this.axios({
                            method: "post",
                            url:
                                "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta_candidat",
                            headers: {},
                            data: {
                                oferta_id: this.ofertaSeleccionada.id,
                                candidat_id: 1,
                            },
                        }).then(function(response) {
                            console.log("oferta_candidad", response);
                        });
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
