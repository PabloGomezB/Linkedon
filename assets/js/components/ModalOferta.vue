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
    methods: {
        enviarCV() {
            this.boxTwo = "";
            console.log("ofertaSeleccionada_id", this.ofertaSeleccionada.id);
            console.log("userLogged_id", this.userLogged.id);
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
                    if (true == value) {
                        this.axios
                            .get(
                                "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/candidat?filter=usuari_id,eq," +
                                    this.userLogged.id
                            )
                            .then((response1) => {
                                console.log(
                                    "candidat_id",
                                    response1.data.records[0].id
                                );
                                this.axios({
                                    method: "post",
                                    url: "/api/setOfertaCandidat",
                                    // "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta_candidat",
                                    headers: {},
                                    data: {
                                        oferta_id: this.ofertaSeleccionada.id,
                                        candidat_id:
                                            response1.data.records[0].id,
                                    },
                                }).then(function(response2) {
                                    console.log(
                                        "post_oferta_candidat",
                                        response2
                                    );
                                    this.$bvModal.hide("modal-oferta");
                                });
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
