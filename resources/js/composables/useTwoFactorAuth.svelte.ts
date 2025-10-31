import { qrCode, recoveryCodes, secretKey } from '@/routes/two-factor';

const fetchJson = async <T>(url: string): Promise<T> => {
	const response = await fetch(url, {
		headers: { Accept: 'application/json' },
	});

	if (!response.ok) {
		throw new Error(`Failed to fetch: ${response.status}`);
	}

	return response.json();
};

export const useTwoFactorAuth = () => {
	let errors = $state<string[]>([]);
	let manualSetupKey = $state<string | null>(null);
	let qrCodeSvg = $state<string | null>(null);
	let recoveryCodesList = $state<string[]>([]);

	const hasSetupData = $derived(qrCodeSvg !== null && manualSetupKey !== null);

	const fetchQrCode = async (): Promise<void> => {
		try {
			const { svg } = await fetchJson<{ svg: string; url: string }>(qrCode.url());

			qrCodeSvg = svg;
		} catch {
			errors.push('Failed to fetch QR code');
			qrCodeSvg = null;
		}
	};

	const fetchSetupKey = async (): Promise<void> => {
		try {
			const { secretKey: key } = await fetchJson<{ secretKey: string }>(secretKey.url());

			manualSetupKey = key;
		} catch {
			errors.push('Failed to fetch a setup key');
			manualSetupKey = null;
		}
	};

	const clearSetupData = (): void => {
		manualSetupKey = null;
		qrCodeSvg = null;
		clearErrors();
	};

	const clearErrors = (): void => {
		errors = [];
	};

	const clearTwoFactorAuthData = (): void => {
		clearSetupData();
		clearErrors();
		recoveryCodesList = [];
	};

	const fetchRecoveryCodes = async (): Promise<void> => {
		try {
			clearErrors();
			recoveryCodesList = await fetchJson<string[]>(recoveryCodes.url());
		} catch {
			errors.push('Failed to fetch recovery codes');
			recoveryCodesList = [];
		}
	};

	const fetchSetupData = async (): Promise<void> => {
		try {
			clearErrors();
			await Promise.all([fetchQrCode(), fetchSetupKey()]);
		} catch {
			qrCodeSvg = null;
			manualSetupKey = null;
		}
	};

	return {
		get qrCodeSvg() {
			return qrCodeSvg;
		},
		get manualSetupKey() {
			return manualSetupKey;
		},
		get recoveryCodesList() {
			return recoveryCodesList;
		},
		get errors() {
			return errors;
		},
		get hasSetupData() {
			return hasSetupData;
		},
		clearSetupData,
		clearErrors,
		clearTwoFactorAuthData,
		fetchQrCode,
		fetchSetupKey,
		fetchSetupData,
		fetchRecoveryCodes,
	};
};
