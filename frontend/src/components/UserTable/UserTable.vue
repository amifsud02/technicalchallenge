<script lang="ts">

import { defineComponent, defineProps } from 'vue';
import { type IUser } from '@/types/user.type';
import UserDetails from '../UserDetails/UserDetails.vue';

defineProps<{
    data: IUser[],
    message: string
}>()

export default defineComponent({
    name: "UserTable",
    data() {
        return {
            // user table variables
            loading: false,
            error: "",
            data: {
                data: [] as IUser[],
                message: "" as string
            },

            // Selecting User
            showUserDetails: false,
            selectedUserId: 0,
            isDisabled: true,

            // Adding New User
            showAddNewUser: false,
        };
    },
    mounted() {
        this.getAllUsersData();
    },
    methods: {
        // Fetching User Data
        async getAllUsersData() {
            this.loading = true;
            this.error = "";
            this.data = {
                data: [],
                message: ""
            };

            try {
                const response = await fetch(`http://127.0.0.1:8000/api/users/`, {
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
            } catch (error) {
                this.loading = false;
                this.error = "Error while fetching data";
                console.error(error);
            }
        },


        async deleteUser(id: number) {
            this.error = ""
            alert("Deleting User");

            try {
                const response = await fetch(`http://127.0.0.1:8000/api/users/${id}`, {
                    method: "DELETE",
                });

                if (response.ok) {
                    // User successfully deleted
                    this.getAllUsersData();
                    console.log("User deleted successfully");
                } else {
                    // An error occurred while deleting the user
                    throw new Error("Failed to delete user");
                }
            } catch (error) {
                this.error = error.message;
                console.error("Error deleting user:", error);
            }
        },

        refreshData() {
            this.getAllUsersData();
        },

        toggleUserModal(userId: number, isDisabled: boolean) {
            if (!this.showUserDetails || this.selectedUserId !== userId) {
                this.showUserDetails = true;
                this.selectedUserId = userId;
            }

            this.isDisabled = isDisabled;
        },

        closeUserModal() {
            this.showUserDetails = !this.showUserDetails;
        },

        toggleIsDisabled() {
            this.isDisabled = !this.isDisabled;
        },


        async addNewUser() {

        },

        toggleAddUser() {
            if (!this.showAddNewUser) {
                this.showAddNewUser = true;
            }

            this.isDisabled = false;
        },

        closeAddUserModal() {
            this.showAddNewUser = !this.showAddNewUser;
        },


    },
    components: {
        UserDetails
    }
})

</script>

<template>
    <div class="modal" v-if="showUserDetails">
        <UserDetails :user-id="selectedUserId" @closeDetails="closeUserModal" :isDisabled="isDisabled" />
    </div>

    <div class="modal" v-if="showAddNewUser">
        <UserDetails @closeDetails="closeAddUserModal" :isDisabled="isDisabled" :addUser="true" />
    </div>

    <div class="button__group">
        <button @click="refreshData">Refresh Data</button>
        <button @click="toggleAddUser">Add New User</button>
    </div>

    <div class="table__container">
        <div class="table__wrapper">
            <div class="table__row table__header__row">
                <div class="table__cell table__header__cell">
                    Id
                </div>
                <div class="table__cell table__header__cell">
                    First Name
                </div>
                <div class="table__cell table__header__cell">
                    Surname
                </div>
                <div class="table__cell table__header__cell">
                    Email
                </div>
                <div class="table__cell table__header__cell">
                    Phone Number
                </div>
                <div class="table__cell table__header__cell">
                    Address 1
                </div>
                <div class="table__cell table__header__cell">
                    Address 2
                </div>
                <div class="table__cell table__header__cell">
                    City
                </div>
                <div class="table__cell table__header__cell">
                    State
                </div>
                <div class="table__cell table__header__cell">
                    Country
                </div>
                <div class="table__cell table__header__cell">
                    Post Code
                </div>
                <div class="table__cell table__header__cell">
                    View / Edit User
                </div>
                <div class="table__cell table__header__cell">
                    Delete User
                </div>
            </div>


            <div class="table__body">

                <!-- Loading Animation -->
                <div v-if="loading" class="table__loading">
                    <div class="lds-ring">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>

                <div>

                    <div v-if="data.data.length > 0">
                        <div class="table__row table__body__row" v-for="(user, index) in data.data" v-bind:key="index">
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.id || '-' }}</span>
                            </div>
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.firstName || '-' }}</span>
                            </div>
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.surname || '-' }}</span>
                            </div>
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.email || '-' }}</span>
                            </div>
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.phoneNumber || '-' }}</span>
                            </div>
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.address1 || '-' }}</span>
                            </div>
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.address2 || '-' }}</span>
                            </div>
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.city || '-' }}</span>
                            </div>
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.state || '-' }}</span>
                            </div>
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.country || '-' }}</span>
                            </div>
                            <div class="table__cell table__body__cell">
                                <span class="text__content">{{ user.postcode || '-' }}</span>
                            </div>

                            <div class="table__cell table__body__cell">
                                <button class="table__action_button action__edit"
                                    @click="$event => toggleUserModal(user.id, false)">
                                    View / Edit
                                </button>
                            </div>
                            <div class="table__cell table__body__cell">
                                <button class="table__action_button action__delete" @click="$event => deleteUser(user.id)">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-if="!loading && data.data.length === 0">
                        <div class="table__row table__body__row no__results">{{ data.message }}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.no__results {
    height: 100px;
    justify-content: center;
    align-items: center;
    background: none;
}

.button__group {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    gap: 10px;
}

.button__group button {
    cursor: pointer;
    padding: 5px;
    border-radius: 5px;
    border: 0;
}

.modal {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    backdrop-filter: blur(5px);
    background-color: rgba(111, 111, 111, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.table__row {
    display: flex;
    flex-direction: row;
}

.table__header__row {
    color: var(--light-gray);
    margin-bottom: 10px;
}

.table__body__row {
    background: var(--dark-gray);
    border: 1px solid var(--light-gray);
    border-bottom: 0;
}

.table__body__row:last-child {
    border: 1px solid var(--light-gray);
}

.table__cell {
    display: flex;
    flex: 0 0 calc(100%/13);
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    min-width: 30px;
    font-weight: normal;
    font-style: normal;
    font-size: 12px;

}

.text__content {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    padding: 0 5px;
}

.action__view {
    color: var(--view);
}

.action__edit {
    margin-right: 5px;
    color: var(--medium);
}

.action__delete {
    margin-left: 5px;
    color: var(--danger);
}

.table__header__cell {
    text-transform: uppercase;
    font-size: 10px;
    font-weight: bold;
    letter-spacing: 0.5px;
}

.table__body__cell {
    border-right: 1px solid var(--light-gray);
    border: 0;
}

.table__body__cell:last-child {
    border: 0;
}

.table__body__cell:first-child,
.table__body__cell:nth-child(11),
.table__body__cell:nth-child(12) {
    border-right: 1px solid var(--light-gray);
}

.table__action_button {
    display: block;
    height: 100%;
    width: 100%;
    padding: 11px 5px;
    background: none;
    border: 0;
    font-size: 12px;
    font-family: 'Adobe Clean UX', sans-serif;
    cursor: pointer;
}

/* LOADING ANIMATION */

.table__loading {
    width: 100%;
    height: 400px;
    display: grid;
    place-items: center;
}

.lds-ring {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
}

.lds-ring div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 64px;
    height: 64px;
    margin: 8px;
    border: 8px solid var(--light-gray);
    border-radius: 50%;
    animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    border-color: var(--light-gray) transparent transparent transparent;
}

.lds-ring div:nth-child(1) {
    animation-delay: -0.45s;
}

.lds-ring div:nth-child(2) {
    animation-delay: -0.3s;
}

.lds-ring div:nth-child(3) {
    animation-delay: -0.15s;
}

@keyframes lds-ring {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>