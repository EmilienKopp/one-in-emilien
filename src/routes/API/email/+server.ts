import { CONTACT_EMAIL, EMAIL, SENDGRID_API_KEY } from "$env/static/private";

import { json } from "@sveltejs/kit";
import sgMail from "@sendgrid/mail";

sgMail.setApiKey(SENDGRID_API_KEY);

export async function GET({ params, request }: any) {
    const data = {
        email: EMAIL
    }
    console.log(JSON.stringify(data));
    return json(data);
}

export async function POST({ params, request }: any) {
    const data = await request.json();
    console.log(JSON.stringify(data));

    const emailMessage = {
        to: EMAIL,
        from: CONTACT_EMAIL,
        subject: "New Contact Form Submission",
        text: `Name: ${data.customer_name}
                \nCompany: ${data.company_name}
                \nEmail: ${data.email}
                \nInquiry: ${data.inquiry}
                \nMessage: ${data.message ?? "None"}
                \nTime: ${new Date().toLocaleString()}    
            `
    }

    const output = await sgMail.send(emailMessage);

    console.log(output);

    return json(data);
}