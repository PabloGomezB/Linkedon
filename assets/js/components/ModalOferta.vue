<template>
    <div>
        <b-modal
            id="modal-oferta"
            :title="ofertaSeleccionada.titol"
            hide-footer
            ref="modal-oferta"
            @hide="resetModal()"
        >
            <b-container fluid>
                <p>{{ ofertaSeleccionada.empresa_id.nom }}</p>
                <p>{{ ofertaSeleccionada.empresa_id.tipus }}</p>
                <p>{{ ofertaSeleccionada.data_publicacio }}</p>
                <p>{{ ofertaSeleccionada.ubicacio }}</p>
                <p>{{ ofertaSeleccionada.descripcio }}</p>
                <p>{{ ofertaSeleccionada.categoria_id.descripcio }}</p>

                <b-form-checkbox
                    v-model="status"
                    value="accepted"
                    unchecked-value="not_accepted"
                    >Añadir carta de presentación
                </b-form-checkbox>
                <div v-if="status == 'accepted'">
                    <b-form-textarea
                        id="textarea"
                        v-model="textCarta"
                        placeholder="Escribe algo..."
                        rows="3"
                        max-rows="6"
                    ></b-form-textarea>
                </div>
            </b-container>
            <div class="mt-3">
                <b-button
                    class="float-right"
                    @click="enviarCV()"
                    variant="primary"
                    >Enviar CV</b-button
                >
            </div>
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
            status: "not_accepted",
            textCarta: "",
        };
    },
    methods: {
        enviarCV() {
            console.log("ofertaSeleccionada_id", this.ofertaSeleccionada.id);
            console.log("userLogged_id", this.userLogged.id);
            this.$bvModal
                .msgBoxConfirm("¿Seguro que quieres enviar el CV?", {
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
                                        carta: this.textCarta,
                                    },
                                }).then((response2) => {
                                    console.log(
                                        "post_oferta_candidat",
                                        response2
                                    );
                                    this.$bvModal.hide("modal-oferta");
                                    this.$emit("forceRerenderEvent");
                                    this.resetModal();
                                });
                            });
                    }
                })
                .catch((err) => {
                    console.log("err", err);
                });
        },
        resetModal() {
            this.status = "not_accepted";
            this.textCarta = "";
        },
    },
};
</script>

<style></style>
