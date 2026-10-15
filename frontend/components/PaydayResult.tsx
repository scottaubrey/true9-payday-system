export const PaydayResultTestIds = {
  payDate: "PaydayResult.payDate",
  paymentDate: "PaydayResult.paymentDate",
};

export const PaydayResult = ({
  payDate,
}: {
  payDate: Date;
  paymentDate?: Date;
}) => (
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
