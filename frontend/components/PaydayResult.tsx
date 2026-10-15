export const PaydayResultTestIds = { payDate: "PaydayResult.payDate" };

export const PaydayResult = ({ payDate }: { payDate: Date }) => (
  <>
    <dl>
      <dt>Pay Date</dt>
      <dd data-testid={PaydayResultTestIds.payDate}>
        {payDate.toLocaleDateString("en-GB", {
          weekday: "long",
          day: "numeric",
          month: "2-digit",
          year: "numeric",
        })}
      </dd>
    </dl>
  </>
);
