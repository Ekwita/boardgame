<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    players: {
        type: Object,
        required: true,
    },
    csrfToken: {
        type: String,
        required: true
    },
    actionUrl: {
        type: String,
        required: true
    }
});

const playerStatus = ref({});
const playerArtifacts = ref({});
const playerGold = ref({});
const playerCarts = ref({});
const playerTokens = ref({});
const playerHasAnyTrueArtifact = ref({});

onMounted(() => {
    Object.keys(props.players).forEach(playerId => {
        const player = props.players[playerId];
        console.log(player);
        playerStatus[player] = '';
        playerArtifacts.value[player] = {
            art5: false,
            art7: false,
            art10: false,
            art12: false,
            art15: false,
            art17: false,
            art20: false,
            art25: false,
            art30: false,
        };
        playerGold[player] = 0;
        playerCarts[player] = 0;
        playerTokens[player] = 0;
        playerHasAnyTrueArtifact.value[player] = false;

        watch(playerArtifacts, (newVal) => {
            Object.keys(newVal).forEach(player => {
                const checkedArtifacts = newVal[player];
                playerHasAnyTrueArtifact.value[player] = Object.values(checkedArtifacts).some(value => value);
            });
        }, { deep: true });
    });
});


function submitForm() {
    document.querySelector('form').submit();
}

</script>

<template>
    <form :action="actionUrl" method="post" @submit.prevent="submitForm">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <input type="hidden" name="_token" :value="csrfToken">
            <div v-for="player in players" :key="player" class="player_points bg-gray-800 text-gray-200 p-4 rounded-md">
                <div class="bg-gray-900 p-2 mb-3 rounded">
                    <span class="font-semibold">Name: {{ player }}</span>
                </div>
                <div class="mb-3">
                    <label :for="'status_' + player" class="block mb-1">Status</label>
                    <select :name="'status_' + player" :id="'status_' + player" v-model="playerStatus[player]"
                        class="w-full p-2 bg-gray-600 text-gray-200 rounded" required>
                        <option value="" disabled>Select a status</option>
                        <option value="3">Escape</option>
                        <option value="2">Alive</option>
                        <option value="1">Dead</option>
                    </select>
                </div>
                <div v-if="playerStatus[player] && Number(playerStatus[player]) !== 1">
                    <div class="mb-3">
                        <div class="artifacts">
                            <label :for="'art5_' + player" class="block mb-1">Artifact - 5 points</label>
                            <input type="checkbox" :id="'art5_' + player" :name="'art5_' + player" class="mb-2"
                                v-model="playerArtifacts[player].art5">
                            <label :for="'art7_' + player" class="block mb-1">Artifact - 7 points</label>
                            <input type="checkbox" :id="'art7_' + player" :name="'art7_' + player" class="mb-2"
                                v-model="playerArtifacts[player].art7">
                            <label :for="'art10_' + player" class="block mb-1">Artifact - 10 points</label>
                            <input type="checkbox" :id="'art10_' + player" :name="'art10_' + player" class="mb-2"
                                v-model="playerArtifacts[player].art10">
                            <label :for="'art12_' + player" class="block mb-1">Artifact - 12 points</label>
                            <input type="checkbox" :id="'art12_' + player" :name="'art12_' + player" class="mb-2"
                                v-model="playerArtifacts[player].art12">
                            <label :for="'art15_' + player" class="block mb-1">Artifact - 15 points</label>
                            <input type="checkbox" :id="'art15_' + player" :name="'art15_' + player" class="mb-2"
                                v-model="playerArtifacts[player].art15">
                            <label :for="'art17_' + player" class="block mb-1">Artifact - 17 points</label>
                            <input type="checkbox" :id="'art17_' + player" :name="'art17_' + player" class="mb-2"
                                v-model="playerArtifacts[player].art17">
                            <label :for="'art20_' + player" class="block mb-1">Artifact - 20 points</label>
                            <input type="checkbox" :id="'art20_' + player" :name="'art20_' + player" class="mb-2"
                                v-model="playerArtifacts[player].art20">
                            <label :for="'art25_' + player" class="block mb-1">Artifact - 25 points</label>
                            <input type="checkbox" :id="'art25_' + player" :name="'art25_' + player" class="mb-2"
                                v-model="playerArtifacts[player].art25">
                            <label :for="'art30_' + player" class="block mb-1">Artifact - 30 points</label>
                            <input type="checkbox" :id="'art30_' + player" :name="'art30_' + player" class="mb-2"
                                v-model="playerArtifacts[player].art30">
                        </div>
                    </div>
                    <div v-if="playerHasAnyTrueArtifact[player]">
                        <div class="mb-3 gold">
                            <label :for="'gold_' + player" class="block mb-1">Gold: </label>
                            <input type="number" :id="'gold_' + player" :name="'gold_' + player"
                                v-model="playerGold[player]" min="0" max="600"
                                class="w-full p-2 bg-gray-600 text-gray-200 rounded">
                        </div>
                        <div v-if="playerGold[player]">
                            <div class="mb-3 tokens">
                                <label :for="'tokens_' + player" class="block mb-1">Tokens: </label>
                                <input type="number" :id="'tokens_' + player" :name="'tokens_' + player"
                                    v-model="playerTokens[player]" min="0" max="600"
                                    class="w-full p-2 bg-gray-600 text-gray-200 rounded">
                            </div>
                            <div v-if="playerTokens[player]">
                                <div class="mb-3 cards">
                                    <label :for="'cards_' + player" class="block mb-1">Cards: </label>
                                    <input type="number" :id="'cards_' + player" :name="'cards_' + player"
                                        v-model="playerCarts[player]" min="0" max="600"
                                        class="w-full p-2 bg-gray-600 text-gray-200 rounded">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label :for="'total_' + player" class="block mb-1">Total points: </label>
                        <input type="number" :id="'total_' + player" :name="'total_' + player" readonly
                            class="w-full p-2 bg-gray-600 text-gray-200 rounded">
                    </div>
                </div>
                <div v-if="playerStatus[player] == 1">
                    You are dead!
                </div>
            </div>
        </div>
        <button type="submit" class="bg-gray-800 text-gray-200 rounded-md p-2 mt-4">Confirm</button>
    </form>
</template>