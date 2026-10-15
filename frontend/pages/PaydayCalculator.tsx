import { useState } from "react";
import { ApiClient } from "../api-client";
import { PaydayForm } from "../components/PaydayForm";
import { PaydayResult } from "../components/PaydayResult";

export const PaydayCalculator = () => {
  const [result, setResult] = useState<
    { payDate: Date; paymentDate: Date } | undefined
  >(undefined);

  const onSubmit = async (year: string, month: string) => {
    const result = await ApiClient.payday(year, month);
    if (result.success) {
      setResult(result.data);
    }
  };

  return (
    <>
      <PaydayForm onSubmit={onSubmit}></PaydayForm>
      {result && <PaydayResult {...result}></PaydayResult>}
    </>
  );
};
