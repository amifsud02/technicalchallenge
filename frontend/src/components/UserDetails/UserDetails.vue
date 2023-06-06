
<script lang="ts">

import { defineComponent, defineProps } from 'vue';
import { type IUser } from '@/types/user.type';
import countries from '@/data/countries.json';
import states from '@/data/states.json';

defineProps<{
    data?: IUser,
    message?: string,
    isDisabled: boolean,
    addUser?: boolean
}>()


export default defineComponent({
    name: 'UserDetails',

    props: {
        userId: {
            type: Number,
            required: false
        },
        isDisabled: {
            type: Boolean,
            required: true,
        },
        addUser: {
            type: Boolean,
            required: false
        }
    },

    data() {
        return {
            // user table variables
            loading: false,
            error: '',
            data: {
                data: {
                    firstName: "",
                    surname: "",
                    email: "",
                    phoneNumber: "",
                    address1: "",
                    address2: "",
                    country: "",
                    state: "",
                    city: "",
                    postcode: ""
                } as IUser,
                message: '' as string
            },
            // COUNTRIES STATES
            availableCountries: [] as string[],
            availableStates: [] as string[],

            selectedCountry: '',
            selectedState: '',
            stateOptions: [] as string[],

            // FORM HANDLING

            changeOccured: false,
            savingData: false,
            savingDataMessage: '',

            // Validation
            errorMessage: {
                firstName: "",
                surname: "",
                email: "",
                phoneNumber: "",
                address1: "",
                address2: "",
                selectedCountry: "",
                selectedState: "",
                city: ""
            }
        }
    },

    methods: {
        async getUserData() {
            this.loading = true;
            this.error = '';
            this.data = {
                data: {},
                message: ''
            }


            try {
                const response = await fetch(`http://127.0.0.1:8000/api/users/${this.userId}`, {
                    method: 'GET',
                    headers: {
                        "Content-Type": "application/json",
                    }
                });

                if (!response.ok) {
                    throw new Error("Error while fetching data");
                }

                const data = await response.json();
                this.loading = false;
                this.data = data;
                this.selectedCountry = data.data.country;
                this.selectedState = data.data.state;
                this.updateStateOptions();
            } catch (error) {
                this.loading = false;
                this.error = "Error while fetching data";
                console.error(error);
            }


        },

        validateForm() {
            let isValid = true;

            // Validate first name
            if (!this.data.data.firstName) {
                this.errorMessage.firstName = 'First name is required.';
                isValid = false;
            } else {
                this.errorMessage.firstName = '';
            }

            // Validate surname
            if (!this.data.data.surname) {
                this.errorMessage.surname = 'Surname is required.';
                isValid = false;
            } else {
                this.errorMessage.surname = '';
            }

            // Validate email
            if (!this.data.data.email) {
                this.errorMessage.email = 'Email is required.';
                isValid = false;
            } else {
                this.errorMessage.email = '';
            }

            // Validate phone number
            if (!this.data.data.phoneNumber) {
                this.errorMessage.phoneNumber = 'Phone number is required.';
                isValid = false;
            } else {
                this.errorMessage.phoneNumber = '';
            }

            // Validate address
            if (!this.data.data.address1) {
                this.errorMessage.address1 = 'Address is required.';
                isValid = false;
            } else {
                this.errorMessage.address1 = '';
            }

            // Validate Country
            if (!this.selectedCountry) {
                this.errorMessage.selectedCountry = 'Country is required.';
                isValid = false;
            } else {
                this.errorMessage.selectedCountry = '';
            }

            // Validate State
            if (this.selectedCountry === 'United States' && !this.selectedState) {
                this.errorMessage.selectedState = 'State is required.';
                isValid = false;
            } else {
                this.errorMessage.selectedState = '';
            }

            // Validate City
            if (!this.data.data.city) {
                this.errorMessage.city = 'City is required.';
                isValid = false;
            } else {
                this.errorMessage.city = '';
            }

            return isValid;
        },

        async saveUserData() {
            if (this.validateForm()) {
                this.savingData = true;

                try {
                    const formData = new URLSearchParams();

                    formData.append("firstName", this.data.data.firstName || "");
                    formData.append("surname", this.data.data.surname || "");
                    formData.append("email", this.data.data.email || "");
                    formData.append("phoneNumber", this.data.data.phoneNumber || "");
                    formData.append("address1", this.data.data.address1 || "");
                    formData.append("address2", this.data.data.address2 || "");
                    formData.append("country", this.selectedCountry || "");
                    formData.append("state", this.selectedState || "");
                    formData.append("city", this.data.data.city || "");
                    formData.append("postcode", this.data.data.postcode || "");

                    console.log(formData)

                    const response = await fetch(`http://127.0.0.1:8000/api/users/${this.userId}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": 'application/x-www-form-urlencoded'
                        },
                        body: formData.toString()
                    });

                    if (response.status === 500) {
                        this.savingDataMessage = "Error while saving data";
                    }

                    this.savingData = false;
                    this.savingDataMessage = "Successfully updated user";

                    await this.getUserData();
                    this.changeOccured = false;

                } catch (error) {
                    this.savingData = false;
                    console.error(error);
                }
            } else {
                return
            }
        },

        async saveNewUser() {

            if (this.validateForm()) {

                this.savingData = true;

                try {
                    const formData = new URLSearchParams();

                    formData.append("firstName", this.data.data.firstName || "");
                    formData.append("surname", this.data.data.surname || "");
                    formData.append("email", this.data.data.email || "");
                    formData.append("phoneNumber", this.data.data.phoneNumber || "");
                    formData.append("address1", this.data.data.address1 || "");
                    formData.append("address2", this.data.data.address2 || "");
                    formData.append("country", this.selectedCountry || "");
                    formData.append("state", this.selectedState || "");
                    formData.append("city", this.data.data.city || "");
                    formData.append("postcode", this.data.data.postcode || "");

                    console.log(formData)

                    const response = await fetch(`http://127.0.0.1:8000/api/users/`, {
                        method: "POST",
                        headers: {
                            "Content-Type": 'application/x-www-form-urlencoded'
                        },
                        body: formData.toString()
                    });

                    if (response.status === 500) {
                        this.savingDataMessage = "Error while adding data";
                    }

                    this.savingData = false;
                    this.savingDataMessage = "Successfully adding user";

                } catch (error) {
                    this.savingData = false;
                    console.error(error);
                }
            }
            else {
                return
            }
        },

        closeModal() {
            this.$emit('closeDetails');
        },

        toggleIsDisabled() {
            this.$emit('toggleIsDisabled');
        },

        updateStateOptions() {
            if (this.selectedCountry === "United States") {
                this.stateOptions = this.availableStates;
            } else {
                this.stateOptions = [];
                this.selectedState = '';
            }
        }
    },

    mounted() {
        if (!this.addUser) {
            this.getUserData()
        }

        this.availableCountries = countries.countries;
        this.availableStates = states.states;
    },

    watch: {
        selectedCountry(newCountry) {
            if (newCountry === "United States") {
                this.stateOptions = this.availableStates;
            } else {
                this.stateOptions = [];
                this.selectedState = ''
            }
        }
    }
})

</script>

<template>
    <div v-if="loading">
        ...loading
    </div>

    <div v-else class="form__container">
        <h3 v-if="addUser">Add New User</h3>
        <h3 v-if="!addUser">View / Edit User</h3>

        <form action="" class="form">
            <div class="form__double">
                <div class="form__group">
                    <label for="" class="form__label">First Name</label>
                    <input class="form__input" type="text" :disabled="isDisabled" v-model="data.data.firstName"
                        @input="changeOccured = true">
                    <span class="error-message">{{ errorMessage.firstName }}</span>
                </div>
                <div class="form__group">
                    <label for="">Surname</label>
                    <input class="form__input" type="text" v-model="data.data.surname" :disabled="isDisabled"
                        @input="changeOccured = true" required>
                    <span class="error-message">{{ errorMessage.surname }}</span>
                </div>
            </div>

            <div class="form__double">
                <div class="form__group">
                    <label for="" class="form__label">Email</label>
                    <input class="form__input" type="text" v-model="data.data.email" :disabled="isDisabled"
                        @input="changeOccured = true" required>
                    <span class="error-message">{{ errorMessage.email }}</span>
                </div>
                <div class="form__group">
                    <label for="" class="form__label">Phone Number</label>
                    <input class="form__input" type="text" v-model="data.data.phoneNumber" :disabled="isDisabled"
                        @input="changeOccured = true" required>
                    <span class="error-message">{{ errorMessage.phoneNumber }}</span>
                </div>
            </div>


            <div class="form__group">
                <label for="" class="form__label">Address 1</label>
                <input class="form__input" type="text" v-model="data.data.address1" :disabled="isDisabled"
                    @input="changeOccured = true">
                <span class="error-message">{{ errorMessage.address1 }}</span>
            </div>
            <div class="form__group">
                <label for="" class="form__label">Address 2</label>
                <input class="form__input" type="text" v-model="data.data.address2" :disabled="isDisabled"
                    @input="changeOccured = true">
            </div>

            <div class="form__double">
                <div class="form__group">
                    <label for="" class="form__label">Country</label>
                    <select class="form__input" v-model="selectedCountry"
                        @input="$event => { changeOccured = true; selectedCountry = $event.target!.value }">
                        <option value="">Select a country</option>
                        <option v-for="country in availableCountries" :value="country" :key="country">{{ country }}</option>
                    </select>
                    <span class="error-message">{{ errorMessage.selectedCountry }}</span>
                </div>
                <div class="form__group">
                    <label for="" class="form__label">State</label>
                    <select v-model="selectedState" :disabled="selectedCountry !== 'United States'" class="form__input"
                        @input="changeOccured = true">
                        <option value="">Select a state</option>
                        <option v-for="state in stateOptions" :value="state" :key="state">{{ state }}</option>
                    </select>
                    <span class="error-message">{{ errorMessage.selectedState }}</span>
                </div>
            </div>

            <div class="form__double">
                <div class="form__group">
                    <label for="" class="form__label">City</label>
                    <input class="form__input" type="text" v-model="data.data.city" :disabled="isDisabled"
                        @input="changeOccured = true">
                    <span class="error-message">{{ errorMessage.city }}</span>
                </div>
                <div class="form__group">
                    <label for="" class="form__label">Post Code</label>
                    <input class="form__input" type="text" v-model="data.data.postcode" :disabled="isDisabled"
                        @input="changeOccured = true">
                </div>
            </div>


            <button type="button" role="button" class="form__button form__success" :disabled="!changeOccured"
                @click="saveUserData" v-if="!addUser">
                <template v-if="!savingData">
                    Save User
                </template>
                <template v-else>
                    <div class="circle-loader"></div>
                </template>
            </button>

            <button type="button" role="button" class="form__button form__success" :disabled="!changeOccured"
                @click="saveNewUser" v-if="addUser">
                <template v-if="!savingData">
                    Add User
                </template>
                <template v-else>
                    <div class="circle-loader"></div>
                </template>
            </button>

            <span>{{ savingDataMessage }}</span>
        </form>
    </div>


    <button @click="closeModal" class="close__button">
        X
    </button>
</template>

<style scoped>
.circle-loader {
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 3px solid #ccc;
    border-top-color: #888;
    animation: circle-loader-animation 1s infinite linear;
}

@keyframes circle-loader-animation {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.error-message {
    color: red;
}

.close__button {
    position: absolute;
    top: 30px;
    right: 30px;
    border-radius: 50%;
    height: 31px;
    width: 31px;
    border: 0;
    background-color: white;
    cursor: pointer;
    font-weight: 900;
}

input:disabled {
    cursor: not-allowed;
    background: lightgray;
}

button:disabled {
    cursor: not-allowed;
    background: lightgray;
}

.form__container {
    width: 60%;
}

.form__header {
    text-align: center;
    margin-bottom: 15px;
}

.divider {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.divider>hr {
    border: 0;
    border-bottom: 1px solid red;
    width: 35%;
}

.divider>h6 {
    font-size: 14px;
}

.form {
    width: 100%;
    padding: 30px;
}

.form__double {
    display: flex;
    flex-direction: row;
    gap: 2%;
}

.divider,
.form,
.form__group,
.form__input {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.form__group {
    padding: 10px 0px;
}

.form__input {
    margin: 5px 0 0 0;
    padding: 10px;
    border: 0;
    border-radius: 5px;
}

.form__button {
    width: fit-content;
    min-width: 150px;
    padding: 10px 7.5px;

    border: 0;
    font-weight: 700;
    border-radius: 5px;
    cursor: pointer;
}

.form__success {
    background-color: var(--success);
}

.form__danger {
    background-color: var(--danger);
    color: white;
}

.form__action {
    display: flex;
    flex-direction: row;
    gap: 10px;
    justify-content: flex-end;
}
</style>