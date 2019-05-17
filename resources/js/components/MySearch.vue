<template>
    <div class="container">
        <ais-instant-search
            :search-client="searchClient"
            index-name="threads"
        >

        <ais-search-box>
            <div slot-scope="{ currentRefinement, isSearchStalled, refine }">
                <input
                    :autofocus="true"
                    placeholder="Search something ..."
                    type="search"
                    class="form-control"
                    v-model="currentRefinement"
                    @input="refine($event.currentTarget.value)"
                >

                <span :hidden="!isSearchStalled">Loading...</span>
            </div>
         </ais-search-box>

        <ais-hits>
            <template slot="item" slot-scope="{ item }">
                <p>
                    <a :href="item.path">
                        {{ item.title }}
                    </a>
                </p>
            </template>
        </ais-hits>

        </ais-instant-search>
    </div>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';

    const algoliaClient = algoliasearch(
        process.env.MIX_ALGOLIA_APP_ID,
        process.env.MIX_ALGOLIA_SEARCH
    );

    const searchClient = {
        async search(requests) {
        // change conditional if any of the other facets are faked"
            if (requests.every(({ params: { query } }) => Boolean(query) === false)) {
                return {
                    results: requests.map(params => {
                    // fake something of the result if used by the search interface
                    return {
                        processingTimeMS: 0,
                        nbHits: 0,
                        hits: [],
                        facets: {},
                    };
                }),
            };
        }
        return algoliaClient.search(requests);
        },
        async searchForFacetValues(requests) {
            return algoliaClient.searchForFacetValues(requests);
        },
    };

    export default {

        data() {
            return {
                searchClient,
            };
        },
    };
</script>
