<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app>
            <v-sheet class="pa-2 text-center">
                <div>Hi, {{ user.name }}</div>
              
            </v-sheet>
            <v-spacer></v-spacer>

            <v-divider></v-divider>

            <v-list>
                <v-list-item v-if="can('settings.manage')" :to="{ name: 'home' }">
                    <template v-slot:prepend>
                        <v-icon color="darkPrimary" icon="mdi-home"></v-icon>
                    </template>

                    <v-list-item-title>
                        {{ $t("message.home") }}</v-list-item-title
                    >
                </v-list-item>
                <v-list-item :to="{ name: 'patients' }">
                    <template v-slot:prepend>
                        <v-icon
                            color="darkPrimary"
                            icon="mdi-account-injury"
                        ></v-icon>
                    </template>

                    <v-list-item-title>Patiens</v-list-item-title>
                </v-list-item>


                <v-list-item :to="{ name: 'appointments' }">
                    <template v-slot:prepend>
                        <v-icon
                            color="darkPrimary"
                            icon="mdi-clipboard-text-clock"
                        ></v-icon>
                    </template>

                    <v-list-item-title>{{
                        $t("message.appointments")
                    }}</v-list-item-title>
                </v-list-item>

               
           
                <v-list-item v-if="can('settings.manage')" :to="{ name: 'settings' }">
                    <template v-slot:prepend>
                        <v-icon color="darkPrimary" icon="mdi-cog"></v-icon>
                    </template>

                    <v-list-item-title>{{
                        $t("message.settings")
                    }}</v-list-item-title>
                </v-list-item>
                
            </v-list>
        </v-navigation-drawer>

        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <template v-slot:append>
                    <v-select
                    class="mt-3 mr-2"
                        :items="$i18n.availableLocales"
                        v-model="$i18n.locale"
                        density="compact"
                        @update:modelValue="changeLanguage"
                        menu
                    >
                    </v-select>
            
                <v-btn
                class="my-auto mr-2"
                    @click="toggleTheme"
                    color="primary"
                    icon="mdi-brightness-6"
                    size="large"
                >
                </v-btn>

            
                <v-btn class="my-auto">
                    <v-avatar
                        id="menu-activator"
                        icon="mdi-doctor"
                        size="small"
                        color="primary"
                        
                    ></v-avatar>
                </v-btn>
                <v-menu activator="#menu-activator">
                    <v-list>
                        <v-list-item>
                            <v-list-item-title>
                                <v-btn @click="logout">{{
                                    $t("message.logOut")
                                }}</v-btn>
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </template>
        </v-app-bar>

        <v-main>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
import { onMounted, ref } from "vue";

import useAuth from "../Composables/auth";
import { useTheme } from "vuetify";
import { useAbility } from '@casl/vue'


export default {
    data: () => ({
        drawer: null,
    }),
    setup() {
        const theme = useTheme();
        const { user, logout } = useAuth();
      
    
        const toggleTheme = () => {
            theme.global.name.value = theme.global.current.value.dark
                ? "myLightTheme"
                : "myDarkTheme";
            localStorage.setItem("userTheme", theme.global.name.value);
        };
        const changeLanguage = (value) => {
            localStorage.setItem('userLanguage', value);
        }
        const { can } = useAbility()
        
        return {
            changeLanguage,
            user,
            logout,
            theme,
            toggleTheme,
            can,
        };
    },
    computed: {
        currentPageTitle() {
            return this.$route.meta.title;
        },
    },
};
</script>
