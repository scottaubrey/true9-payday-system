export const PaydayFormTestIds = {
  month: "PaydayForm.month",
  year: "PaydayForm.year",
  submitButton: "PaydayForm.submitButton",
};

export const PaydayForm = () => (
  <form>
    <select data-testid={PaydayFormTestIds.month} name="month" required>
      <option value="01">January</option>
      <option value="02">February</option>
      <option value="03">March</option>
      <option value="04">April</option>
      <option value="05">May</option>
      <option value="06">June</option>
      <option value="07">July</option>
      <option value="08">August</option>
      <option value="09">September</option>
      <option value="10">October</option>
      <option value="11">November</option>
      <option value="12">December</option>
    </select>
    <input
      data-testid={PaydayFormTestIds.year}
      type="number"
      min="2026"
      max="9999"
      name="year"
    ></input>
    <button data-testid={PaydayFormTestIds.submitButton} type="button">
      Calculate dates
    </button>
  </form>
);
