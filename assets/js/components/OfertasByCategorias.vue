<template>
    <div>
        <h1>Ofertas por categorias</h1>
        <b-form-select v-model="selected" :options="options"></b-form-select>
        <div class="mt-3">
            Selected: <strong>{{ selected }}</strong>
        </div>

        <div>
            <b-card-group deck>
                <b-card
                    title="Title"
                    img-src="https://picsum.photos/300/300/?image=41"
                    img-alt="Image"
                    img-top
                >
                    <b-card-text>
                        This is a wider card with supporting text below as a
                        natural lead-in to additional content. This content is a
                        little bit longer.
                    </b-card-text>
                    <template #footer>
                        <small class="text-muted"
                            >Last updated 3 mins ago</small
                        >
                    </template>
                </b-card>

                <b-card
                    title="Title"
                    img-src="https://picsum.photos/300/300/?image=41"
                    img-alt="Image"
                    img-top
                >
                    <b-card-text>
                        This card has supporting text below as a natural lead-in
                        to additional content.
                    </b-card-text>
                    <template #footer>
                        <small class="text-muted"
                            >Last updated 3 mins ago</small
                        >
                    </template>
                </b-card>

                <b-card
                    title="Title"
                    img-src="https://picsum.photos/300/300/?image=41"
                    img-alt="Image"
                    img-top
                >
                    <b-card-text>
                        This is a wider card with supporting text below as a
                        natural lead-in to additional content. This card has
                        even longer content than the first to show that equal
                        height action.
                    </b-card-text>
                    <template #footer>
                        <small class="text-muted"
                            >Last updated 3 mins ago</small
                        >
                    </template>
                </b-card>
            </b-card-group>
        </div>
    </div>
</template>

<script>
export default {
    name: "OfertasByCategorias",
    data() {
        return {
            selected: null,
            options: [
                { value: null, text: "Please select some item" },
                { value: "a", text: "This is First option" },
                { value: "b", text: "Default Selected Option" },
                { value: "c", text: "This is another option" },
                { value: "d", text: "This one is disabled", disabled: true },
            ],
            resultadoOfertas: "",
        };
    },
    methods: {
        getOfertas() {
            this.axios
                .get(
                    "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta"
                )
                .then((response) => {
                    console.log(response);
                    this.resultadoOfertas = response.data.records;
                });
        },
    },
    created() {
        this.getOfertas();
    },
};
</script>

<style></style>
