import type { InertiaLinkProps } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import type { ComputedRef, DeepReadonly } from 'vue';
import { computed, readonly } from 'vue';

type Url = NonNullable<InertiaLinkProps['href']>;

export type UseCurrentUrlReturn = {
    currentUrl: DeepReadonly<ComputedRef<string>>;

    isCurrentUrl: (
        urlToCheck: Url,
        currentUrl?: string,
        startsWith?: boolean,
    ) => boolean;

    isCurrentOrParentUrl: (urlToCheck: Url, currentUrl?: string) => boolean;

    whenCurrentUrl: <T, F = null>(
        urlToCheck: Url,
        ifTrue: T,
        ifFalse?: F,
    ) => T | F;
};

const page = usePage();

const currentUrlReactive = computed(() => {
    return new URL(
        page.url,
        typeof window !== 'undefined'
            ? window.location.origin
            : 'http://localhost',
    ).pathname;
});

export function useCurrentUrl(): UseCurrentUrlReturn {
    const normalizeUrl = (url: Url): string => {
        if (typeof url === 'string') {
            return url.split('?')[0];
        }

        return url.url.split('?')[0];
    };

    const isCurrentUrl = (
        urlToCheck: Url,
        currentUrl: string = page.url,
        startsWith = false,
    ): boolean => {
        const url = normalizeUrl(urlToCheck);
        const current = currentUrl.split('?')[0];

        if (startsWith) {
            return current === url || current.startsWith(`${url}/`);
        }

        return current === url;
    };

    const isCurrentOrParentUrl = (
        urlToCheck: Url,
        currentUrl: string = page.url,
    ): boolean => {
        return isCurrentUrl(urlToCheck, currentUrl, true);
    };

    const whenCurrentUrl = <T, F = null>(
        urlToCheck: Url,
        ifTrue: T,
        ifFalse?: F,
    ): T | F => {
        return isCurrentUrl(urlToCheck) ? ifTrue : (ifFalse as F);
    };

    return {
        currentUrl: readonly(currentUrlReactive),
        isCurrentUrl,
        isCurrentOrParentUrl,
        whenCurrentUrl,
    };
}
