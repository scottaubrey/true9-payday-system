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
        <dialog open data-testid={PaydayCalculatorTestIds.error}>
          <article>
            <p>Please review your form and try again.</p>
          </article>
        </dialog>
      )}
    </>
  );
};
