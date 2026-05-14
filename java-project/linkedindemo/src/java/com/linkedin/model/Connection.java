package com.linkedin.model;

import java.sql.PreparedStatement;
import java.sql.Timestamp;

public class Connection {
    private int id;
    private int requesterId;
    private int addresseeId;
    private String status;
    private Timestamp createdAt;
    private String requesterName;
    private String addresseeName;

    // Constructors
    public Connection() {}

    public Connection(int requesterId, int addresseeId) {
        this.requesterId = requesterId;
        this.addresseeId = addresseeId;
    }

    // Getters and Setters
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public int getRequesterId() { return requesterId; }
    public void setRequesterId(int requesterId) { this.requesterId = requesterId; }

    public int getAddresseeId() { return addresseeId; }
    public void setAddresseeId(int addresseeId) { this.addresseeId = addresseeId; }

    public String getStatus() { return status; }
    public void setStatus(String status) { this.status = status; }

    public Timestamp getCreatedAt() { return createdAt; }
    public void setCreatedAt(Timestamp createdAt) { this.createdAt = createdAt; }

    public String getRequesterName() { return requesterName; }
    public void setRequesterName(String requesterName) { this.requesterName = requesterName; }

    public String getAddresseeName() { return addresseeName; }
    public void setAddresseeName(String addresseeName) { this.addresseeName = addresseeName; }

    public PreparedStatement prepareStatement(String sql) {
        throw new UnsupportedOperationException("Not supported yet."); // Generated from nbfs://nbhost/SystemFileSystem/Templates/Classes/Code/GeneratedMethodBody
    }
}