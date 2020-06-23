<template>
    <div>
        <div class="alert alert-info current-package" v-if="account && account.package_id">
            <p>Your package: <strong>{{ account.package.name }}</strong></p>
            <p>Start date: <strong>{{ account.package_start_date | formatDateTime }}</strong></p>
            <p>End date: <strong>{{ account.package_end_date | formatDateTime }}</strong></p>
            <p>Available quota: <strong>{{ account.package_available_quota }}/{{ account.package.number_of_listings }} {{ __('properties') }}</strong></p>
        </div>
        <div class="packages-listing">
            <div class="row flex-items-xs-middle flex-items-xs-center">
                <div style="margin: auto; width:30px;" v-if="isLoading">
                    <half-circle-spinner
                        :animation-duration="1000"
                        :size="15"
                        color="#808080"
                    />
                </div>
                <div :class="data.length < 4 ? 'col-xs-12 col-lg-' + (12/data.length) : 'col-xs-12 col-lg-4'" v-for="item in data" :key="item.id" v-if="!isLoading && data.length && account && item.id !== account.package_id">
                    <div class="card text-xs-center">
                        <div class="card-header">
                            <h3 class="display-2"><span class="currency">$</span>{{ item.price }}<span class="period">/{{ item.number_of_days }} {{ __('days') }}</span></h3>
                        </div>
                        <div class="card-block">
                            <h4 class="card-title">
                                {{ item.name }}
                            </h4>
                            <ul class="list-group">
                                <li class="list-group-item">{{ __('Can post properties') }}: {{ item.number_of_listings }}</li>
                                <li class="list-group-item">{{ __('Package duration') }}: {{ item.number_of_days }} {{ __('days') }}</li>
                            </ul>
                            <button :class="isSubscribing && currentPackageId === item.id ? 'btn btn-primary mt-2 button-loading' : 'btn btn-primary mt-2'" @click="postSubscribe(item.id)">{{ __('Choose Plan') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {HalfCircleSpinner} from 'epic-spinners'

    export default {
        components: {
            HalfCircleSpinner
        },

        data: function() {
            return {
                isLoading: true,
                isSubscribing: false,
                data: [],
                account: {},
                currentPackageId: null,
            };
        },

        mounted() {
            this.getData();
        },

        props: {
            url: {
                type: String,
                default: () => null,
                required: true
            },
            subscribe_url: {
                type: String,
                default: () => null,
                required: true
            },
        },

        methods: {
            getData() {
                this.data = [];
                this.isLoading = true;
                axios.get(this.url)
                    .then((res) => {
                        if (res.data.error) {
                            Botble.showError(res.data.message);
                        } else {
                            this.data = res.data.data.packages;
                            this.account = res.data.data.account;
                        }
                        this.isLoading = false;
                    });
            },

            postSubscribe(id) {
                this.isSubscribing = true;
                this.currentPackageId = id;
                axios.put(this.subscribe_url, {id: id})
                    .then((res) => {
                        if (res.data.error) {
                            Botble.showError(res.data.message);
                        } else {
                            if (res.data.data && res.data.data.next_page) {
                                window.location.href = res.data.data.next_page;
                            } else {
                                this.account = res.data.data;
                            }
                        }
                        this.isSubscribing = false;
                    });
            }
        }
    }
</script>
