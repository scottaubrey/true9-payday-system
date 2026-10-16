import { useState } from "react";
import { ApiClient } from "../api-client";
import { PaydayForm } from "../components/PaydayForm";
import { PaydayResult } from "../components/PaydayResult";

export const PaydayCalculatorTestIds = {
  error: "PaydayCalculatorTestIds.error",
  closeErrorDialog: "PaydayCalculatorTestIds.closeErrorDialog",
};

export const PaydayCalculator = () => {
  const [result, setResult] = useState<
    { payDate: Date; paymentDate: Date } | undefined
  >(undefined);
  const [error, setError] = useState(false);
  const resetError = () => {
    setError(false);
  };

  const onSubmit = async (year: string, month: string) => {
    setError(false);
    const result = await ApiClient.payday(year, month);
    if (result.success) {
      setResult(result.data);
    } else {
      setError(true);
    }
  };

  return (
    <>
      <PaydayForm onSubmit={onSubmit}></PaydayForm>
      {result && <PaydayResult {...result}></PaydayResult>}
      {error && (
        // biome-ignore  lint/a11y/useKeyWithClickEvents: dialog closedby="any" already handles keyboard escape natively
        <dialog
          open
          data-testid={PaydayCalculatorTestIds.error}
          closedby="any"
          onClick={resetError}
        >
          <article>
            <header>
              <button
                onClick={resetError}
                type="button"
                aria-label="Close"
                rel="prev"
                data-testid={PaydayCalculatorTestIds.closeErrorDialog}
              ></button>
              <p>
                <strong>An error occurred.</strong>
              </p>
            </header>
            <p>Please review your form and try again.</p>
          </article>
        </dialog>
      )}
    </>
  );
};
