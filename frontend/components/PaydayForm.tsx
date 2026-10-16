import { useRef, useState } from "react";

export const PaydayFormTestIds = {
  form: "PaydayForm.form",
  month: "PaydayForm.month",
  year: "PaydayForm.year",
  submitButton: "PaydayForm.submitButton",
  payDateResult: "PaydayForm.payDateResult",
};

export const PaydayForm = ({
  onSubmit,
}: {
  onSubmit?: (year: string, month: string) => void;
}) => {
  const nowDateRef = useRef(new Date());
  const [formValues, setFormValues] = useState({
    month: String(nowDateRef.current.getMonth() + 1),
    year: String(nowDateRef.current.getFullYear()),
  });

  const onClickHandler = async () => {
    if (onSubmit) {
      onSubmit(formValues.year, formValues.month);
    }
  };

  return (
    <form data-testid={PaydayFormTestIds.form}>
      <select
        data-testid={PaydayFormTestIds.month}
        name="month"
        required
        value={formValues.month}
        onChange={(e) =>
          setFormValues({ ...formValues, month: e.target.value })
        }
      >
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
      </select>
      <input
        data-testid={PaydayFormTestIds.year}
        type="number"
        min={nowDateRef.current.getFullYear()}
        max="9999"
        name="year"
        value={formValues.year}
        onChange={(e) => setFormValues({ ...formValues, year: e.target.value })}
      ></input>
      <button
        data-testid={PaydayFormTestIds.submitButton}
        type="button"
        onClick={onClickHandler}
      >
        Calculate dates
      </button>
    </form>
  );
};
